#!/bin/bash
var=$(date +"%FORMAT_STRING")
now=$(date +"%Y%m%d")
TOKEN="dmdy42z1uyefs3hgq74xfjrpb5xr7hbw"
URL="https://app.walkingdocs.com/external/checklists"
OUTFILE="checklists.json"

path = "/var/www/html/walkingdocs/walkingdocs/assets/checklists/temp"
curl -H "Authorization: $TOKEN" $URL > "/var/www/html/walkingdocs/walkingdocs/assets/checklists/temp"
cd "/var/www/html/walkingdocs/walkingdocs/assets/checklists"
reno=$(ls -v *.json | tail -n 1)
echo ${reno}

if cmp -s "${reno}" "temp";
then
echo 'THE SAME'
rm -f "temp"
else
#echo 'DIFFERENT'
mv "temp" "${now}.json"
fi