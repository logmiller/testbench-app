#!/bin/bash

# Author: Logan Miller
#
#   This script allows a developer to wipe their database out
#   and recreate the tables for this example from scratch.
MYSQL=`which mysql`
if [ "$MYSQL" == "" ]; then
  echo "mysql client tools not installed."
  exit 255
else
  hostname='localhost'
  dbname='crud'
  username='test_user'
  password='!Test1234Password!'

  # Create initial database.
  mysql --defaults-extra-file=<(\
    printf '[create]\nuser = %s\npassword=%s\nhostname = %s\n' "$username" "$password" "$hostname"\
  ) -e "DROP DATABASE IF EXISTS $dbname; CREATE DATABASE $dbname;"

  # Grant all privileges on db for test user.
  mysql --defaults-extra-file=<(\
    printf '[create]\nuser = %s\npassword=%s\nhostname = %s\n' "$username" "$password" "$hostname"\
  ) --database=$dbname -e "CREATE USER IF NOT EXISTS '$username'@'$hostname' IDENTIFIED BY '$password';
      GRANT ALL PRIVILEGES ON $dbname.* TO '$username'@'$hostname';"


  # Creates CustomerList table
  mysql --defaults-extra-file=<(\
    printf '[create]\nuser = %s\npassword=%s\nhostname = %s\n' "$username" "$password" "$hostname"\
  ) --database=$dbname -e "DROP TABLE IF EXISTS CustomerList; CREATE Table CustomerList (
      CustomerID int NOT NULL,
      FirstName varchar(32),
      LastName varchar(32),
      Email varchar(128),
      PhoneNumber varchar(16),
      Address varchar(128),
      City varchar(64),
      State char(2),
      PRIMARY KEY (CustomerID)
  );"

  # Creates CustomerNotes table.
  mysql --defaults-extra-file=<(\
    printf '[create]\nuser = %s\npassword=%s\nhostname = %s\n' "$username" "$password" "$hostname"\
  ) --database=$dbname -e "DROP TABLE IF EXISTS CustomerNotes; CREATE Table CustomerNotes (
      NoteID int NOT NULL,
      Note tinytext,
      CustomerID int,
      PRIMARY KEY (NoteID),
      FOREIGN KEY (CustomerID) REFERENCES CustomerList(CustomerID)
  );"

  # Populate generated tables.
  echo -e "\033[0;32;40mbegin populating tables...\033[0m\n"
  mysql --defaults-extra-file=<(\
    printf '[restore]\nuser = %s\npassword=%s\nhostname = %s\n' "$username" "$password" "$hostname"\
  ) --database=$dbname < 'example.sql'

  # Display CustomerList and CustomerNotes.
  mysql --defaults-extra-file=<(\
    printf '[create]\nuser = %s\npassword=%s\nhostname = %s\n' "$username" "$password" "$hostname"\
  ) --database=$dbname -e "SELECT * FROM CustomerList; SELECT * FROM CustomerNotes;"
fi
echo -e "\033[0;32;40minitial setup finished\033[0m\n"

COMPOSER=`which composer`
if [ "$COMPOSER" == "" ]; then
  echo "composer not installed."
  exit 255
else
  # update vendor files.
  if [[ $EUID -ne 0 ]]; then
    composer dump-autoload -o
  else
    echo -e "\033[0;31;40mComposer must not be run as root. Skipping autoloader updates.\033[0m\n"
    exit 1
  fi
fi