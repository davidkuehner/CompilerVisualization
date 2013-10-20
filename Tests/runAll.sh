#!/bin/bash

clear

echo "All units/* tests will be executed."
echo "-----------------------------------"
echo 

for file in ./units/*
do
  php mageekguy.atoum.phar $file
done
