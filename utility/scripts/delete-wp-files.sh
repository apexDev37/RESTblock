#!/bin/bash
# Delete all mounted WordPress files
# in the project roor dir
#
# Instructions:
# sudo chmod +x delete-wp-files.sh
# sudo ./delete-wp-files.sh

# Navigate to the project root dir
cd ../../

# Find and delete all folders owned by www-data
find . -user www-data -type d -exec rm -rf {} \;

# Find and delete all files owned by www-data
find . -user www-data -type f -delete
