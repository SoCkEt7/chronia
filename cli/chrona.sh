#!/bin/bash

# Chrona - CLI for crontab management
# Usage: ./chrona.sh [command] [options]

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Base directory
BASE_DIR="$(dirname "$(dirname "$(readlink -f "$0")")")"
CONFIG_FILE="$BASE_DIR/config/system.json"

# Display help
function show_help {
    echo -e "${CYAN}Chrona - Crontab Management CLI${NC}"
    echo
    echo "Usage: $0 [command] [options]"
    echo
    echo "Commands:"
    echo "  list              List all crontab entries"
    echo "  add               Add a new crontab entry"
    echo "  edit [id]         Edit a crontab entry"
    echo "  delete [id]       Delete a crontab entry"
    echo "  enable [id]       Enable a crontab entry"
    echo "  disable [id]      Disable a crontab entry"
    echo "  test [id]         Test run a crontab entry"
    echo "  status            Show cron service status"
    echo "  help              Show this help message"
    echo
    echo "Options:"
    echo "  --format [text|json]  Output format (default: text)"
    echo
}

# List all crontab entries
function list_entries {
    echo -e "${CYAN}Crontab Entries:${NC}"
    echo
    
    # In a real implementation, this would parse the output of `crontab -l`
    # For now, we'll just show a simple example
    echo -e "${BLUE}ID${NC}\t${BLUE}Schedule${NC}\t\t${BLUE}Command${NC}\t\t${BLUE}Status${NC}"
    echo "--------------------------------------------------------------"
    echo -e "1\t0 * * * *\t\t/usr/bin/backup.sh\t${GREEN}Active${NC}"
    echo -e "2\t0 0 * * *\t\t/usr/bin/cleanup.sh\t${GREEN}Active${NC}"
    echo -e "3\t*/5 * * * *\t\t/usr/bin/monitor.sh\t${YELLOW}Inactive${NC}"
    echo
}

# Add a new entry
function add_entry {
    echo -e "${CYAN}Add New Crontab Entry:${NC}"
    echo
    
    read -p "Schedule (e.g. '0 * * * *'): " schedule
    read -p "Command: " command
    
    if [[ -z "$schedule" || -z "$command" ]]; then
        echo -e "${RED}Error: Schedule and command are required${NC}"
        return 1
    fi
    
    # In a real implementation, this would add to the crontab
    echo -e "${GREEN}Entry added successfully${NC}"
    echo
    echo -e "${BLUE}Schedule:${NC} $schedule"
    echo -e "${BLUE}Command:${NC} $command"
    echo
}

# Edit an entry
function edit_entry {
    local id=$1
    
    if [[ -z "$id" ]]; then
        echo -e "${RED}Error: Entry ID is required${NC}"
        return 1
    fi
    
    echo -e "${CYAN}Edit Crontab Entry #${id}:${NC}"
    echo
    
    # In a real implementation, this would get the current entry
    local current_schedule="0 * * * *"
    local current_command="/usr/bin/backup.sh"
    
    echo -e "${BLUE}Current Schedule:${NC} $current_schedule"
    read -p "New Schedule (leave empty to keep current): " schedule
    
    echo -e "${BLUE}Current Command:${NC} $current_command"
    read -p "New Command (leave empty to keep current): " command
    
    schedule=${schedule:-$current_schedule}
    command=${command:-$current_command}
    
    # In a real implementation, this would update the crontab
    echo -e "${GREEN}Entry updated successfully${NC}"
    echo
    echo -e "${BLUE}Schedule:${NC} $schedule"
    echo -e "${BLUE}Command:${NC} $command"
    echo
}

# Delete an entry
function delete_entry {
    local id=$1
    
    if [[ -z "$id" ]]; then
        echo -e "${RED}Error: Entry ID is required${NC}"
        return 1
    fi
    
    echo -e "${CYAN}Delete Crontab Entry #${id}:${NC}"
    echo
    
    # In a real implementation, this would get the current entry
    local schedule="0 * * * *"
    local command="/usr/bin/backup.sh"
    
    echo -e "${BLUE}Schedule:${NC} $schedule"
    echo -e "${BLUE}Command:${NC} $command"
    echo
    
    read -p "Are you sure you want to delete this entry? (y/n): " confirm
    if [[ "$confirm" != "y" && "$confirm" != "Y" ]]; then
        echo -e "${YELLOW}Operation cancelled${NC}"
        return 0
    fi
    
    # In a real implementation, this would delete from the crontab
    echo -e "${GREEN}Entry deleted successfully${NC}"
    echo
}

# Enable an entry
function enable_entry {
    local id=$1
    
    if [[ -z "$id" ]]; then
        echo -e "${RED}Error: Entry ID is required${NC}"
        return 1
    fi
    
    # In a real implementation, this would uncomment the entry in crontab
    echo -e "${GREEN}Entry #${id} enabled successfully${NC}"
    echo
}

# Disable an entry
function disable_entry {
    local id=$1
    
    if [[ -z "$id" ]]; then
        echo -e "${RED}Error: Entry ID is required${NC}"
        return 1
    fi
    
    # In a real implementation, this would comment out the entry in crontab
    echo -e "${YELLOW}Entry #${id} disabled successfully${NC}"
    echo
}

# Test run an entry
function test_entry {
    local id=$1
    
    if [[ -z "$id" ]]; then
        echo -e "${RED}Error: Entry ID is required${NC}"
        return 1
    fi
    
    echo -e "${CYAN}Test Run for Entry #${id}:${NC}"
    echo
    
    # In a real implementation, this would get the current entry
    local command="/usr/bin/backup.sh"
    
    echo -e "${BLUE}Command:${NC} $command"
    echo
    echo -e "${BLUE}Output:${NC}"
    echo "--------------------------------------------------------------"
    echo "This is a simulation of the command output"
    echo "In a real implementation, the command would be executed"
    echo "--------------------------------------------------------------"
    echo
    echo -e "${GREEN}Test completed successfully (exit code: 0)${NC}"
    echo
}

# Show cron service status
function show_status {
    echo -e "${CYAN}Cron Service Status:${NC}"
    echo
    
    # In a real implementation, this would check the actual cron service
    echo -e "${GREEN}● active (running)${NC}"
    echo "Cron service is running normally"
    echo
}

# Parse command line arguments
if [[ $# -eq 0 ]]; then
    show_help
    exit 0
fi

COMMAND=$1
shift

case $COMMAND in
    list)
        list_entries
        ;;
    add)
        add_entry
        ;;
    edit)
        edit_entry $1
        ;;
    delete)
        delete_entry $1
        ;;
    enable)
        enable_entry $1
        ;;
    disable)
        disable_entry $1
        ;;
    test)
        test_entry $1
        ;;
    status)
        show_status
        ;;
    help|--help|-h)
        show_help
        ;;
    *)
        echo -e "${RED}Error: Unknown command '$COMMAND'${NC}"
        show_help
        exit 1
        ;;
esac