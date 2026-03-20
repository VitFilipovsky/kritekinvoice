#!/bin/bash
echo ""
printf '\033[1;33m'
cat << 'EOF'
  ███  █   █  ███  █████       ███    ███   ███    ███   ███   █████
   █   ██  █   █     █       █       █      █  █    █    █  █    █
   █   █ █ █   █     █       ███    ██      █   █   █    ███     █
   █   █  ██   █     █          █    █      █ █     █    █       █
  ███  █   █  ███    █       ███      ███   █  █   ███   █       █
EOF
printf '\033[0m'

echo ""
echo "┌─────────────────────────────────────────────────────┐"
echo "│                    ⚠  WARNING  ⚠                    │"
echo "│                                                     │"
echo "│  This script will perform the following actions:    │"
echo "│                                                     │"
echo "│  • Stop all Docker containers                       │"
echo "│  • Reinitialize and rebuild all containers          │"
echo "│  • Reset settings and content of all containers     │"
echo "│  • Load a fresh database (existing data will be     │"
echo "│    PERMANENTLY DELETED)                             │"
echo "│  • Rebuild JavaScript assets                        │"
echo "│                                                     │"
echo "└─────────────────────────────────────────────────────┘"
echo ""

read -r -p "Are you sure you want to continue? [yes/N] " response
if [[ ! "$response" =~ ^[Yy][Ee][Ss]$ ]]; then
    echo "Aborted."
    exit 0
fi

echo ""

set -e

if docker compose version &>/dev/null 2>&1; then
    DOCKER_COMPOSE=(docker compose)
elif command -v docker-compose &>/dev/null 2>&1; then
    DOCKER_COMPOSE=(docker-compose)
else
    echo "ERROR: docker compose not found." >&2
    exit 1
fi

"${DOCKER_COMPOSE[@]}" down
"${DOCKER_COMPOSE[@]}" up --build -d

TIMEOUT=60

wait_for_container() {
    local name=$1
    local check_cmd=$2
    local elapsed=0

    until eval "$check_cmd" &>/dev/null 2>&1; do
        if [ $elapsed -ge $TIMEOUT ]; then
            echo "ERROR: ${name} did not start within ${TIMEOUT}s" >&2
            exit 1
        fi
        sleep 2
        elapsed=$((elapsed + 2))
    done
    echo "${name} ready."
}

wait_for_container "MySQL"   "docker exec kritekinvoice_mysql mysqladmin ping -u root --silent"
wait_for_container "PHP"     "docker exec kritekinvoice_php php -r 'echo 1;'"
wait_for_container "Node.js" "docker exec kritekinvoice_node node --version"

echo "Project initialized successfully."

echo "Setting up database..."
docker exec kritekinvoice_php bash -c 'php app/bin/console doctrine:database:drop --force'
docker exec kritekinvoice_php bash -c 'php app/bin/console doctrine:database:create'
docker exec kritekinvoice_php bash -c 'php app/bin/console doctrine:migrations:migrate'

echo "Rebuilding JavaScript assets..."
docker exec kritekinvoice_node bash -c 'cd /var/www/html/app && npm install'
docker exec kritekinvoice_node bash -c 'cd /var/www/html/app && npm run build'

echo ""
docker ps
make phpstan
