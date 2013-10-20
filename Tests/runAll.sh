#!/bin/bash

clear
printf "\n\n\n"
echo "All units/* tests will be executed."
echo "-----------------------------------"
printf "\n\n\n"

for file in ./units/*
do
  php mageekguy.atoum.phar $file
  printf "\n\n"
done

printf "\n\n"
