#!/bin/bash

read regex
regex=$(printf $regex | tr -d '\n')

echo '<!doctype html><html><head><meta charset="utf-8"></head><body>' > index.html
echo $(echo $regex | hoa compiler:pp --visitor-class Hoathis.Regex.Visitor.Visualization hoa://Library/Regex/Grammar.pp 0) >>index.html

echo '</body></html>' >> index.html

firefox ./index.html 2> /dev/null
