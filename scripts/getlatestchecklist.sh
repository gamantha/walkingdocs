#!/bin/bash
var=$(date +"%FORMAT_STRING")
now=$(date +"%Y%m%d%H")
path = "/var/www/html/walkingdocs/walkingdocs/assets/checklists/temp"
curl "https://app.walkingdocs.com/external/checklists" --compressed \
> "/var/www/html/walkingdocs/walkingdocs/assets/checklists/temp"
cd "/var/www/html/walkingdocs/walkingdocs/assets/checklists"
reno=$(ls -v *.json | tail -n 1)
echo ${reno}

if cmp -s "${reno}" "temp";
then
echo 'THE SAME - overwrite'
#mv "temp" "${now}.json"
rm "temp"
else
#echo 'DIFFERENT'
mv "temp" "${now}.json"
fi
