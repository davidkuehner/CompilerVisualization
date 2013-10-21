#!/bin/bash
GREEN="\\033[1;32m"
RED="\\033[1;31m"
GRAY="\\033[0;39m"

clear
printf "\n\n\n"
echo "All units/* tests will be executed."
echo "-----------------------------------"
printf "\n\n\n"
let count=0

for file in ./units/*
do
  php mageekguy.atoum.phar $file | tee -a ./log
  ((count++))
  printf "\n\n"
done

success=$(cat ./log | grep 'Success' -c)

if [ "$success" -eq "$count" ]
then
echo -e "$GREEN"
else
echo -e "$RED"
fi

printf "Success : %d / %d" $success $count

 echo -e "$GRAY" 

printf "\n\n"
rm ./log
