#!/bin/bash
# Add the host user to the www-data user group
# to give host user write permissions to mounted
# WordPress files.
#
# Instructions:
# sudo chmod +x handle-wp-permissions.sh
# ./handle-wp-permissions.sh

# Get the username of the user with the ID 1000.
username=$(awk -F: -v uid=1000 '$3 == uid { print $1 }' /etc/passwd)

# Add the user to the www-data group.
usermod -aG www-data $username

# Give group www-data write permissions.
cd ../../
sudo chmod -R 775 wp-content

# Log out and back in to apply the changes.
echo "Please log out and back in to apply the changes."