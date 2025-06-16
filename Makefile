.PHONY: up dup down shell tinker help

default: up

up:
	sudo docker compose up

dup:
	sudo docker compose up

down:
	sudo docker compose down

shell:
	sudo docker exec -it galera_backend sh

tinker:
	sudo docker exec -it galera_backend php artisan tinker

help:
	@echo "Laravel Sail API Development Commands:"
	@echo ""
	@echo "\033[34mContainer Management:\033[0m"
	@printf "  \033[36m%-18s\033[0m %s\n" "up" "Start Docker container"
	@printf "  \033[36m%-18s\033[0m %s\n" "dup" "Start Docker container in detached mode"
	@printf "  \033[36m%-18s\033[0m %s\n" "down" "Stop and remove containers"
	@echo ""
	@echo "\033[34mDevelopment Tools:\033[0m"
	@printf "  \033[36m%-18s\033[0m %s\n" "shell" "Enter container bash shell"
	@printf "  \033[36m%-18s\033[0m %s\n" "tinker" "Enter tinker container"
	@echo ""
	@echo "Run \033[33mmake <command>\033[0m to execute any of these."
	@echo "If no \033[33m<command>\033[0m is provided, \033[33mup\033[0m will run by default."

%:
	@: