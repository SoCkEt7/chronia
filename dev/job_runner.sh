#!/bin/bash
# Development job runner that simulates running cron jobs

if [ $# -eq 0 ]; then
    echo "Error: No command provided"
    exit 1
fi

echo "====== DEVELOPMENT MODE ======"
echo "Would execute: $@"
echo "=============================="

# Simulate success or failure randomly
if [ $((RANDOM % 10)) -gt 2 ]; then
    echo "Simulated successful execution"
    exit 0
else
    echo "Simulated failure for testing"
    exit 1
fi
