#!/bin/bash
var=$(date +"%FORMAT_STRING")
now=$(date +"%Y%m%d%H")
path = "/var/www/html/walkingdocs/walkingdocs/assets/checklists/temp"
curl -H "Authorization : eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoiam9obmRvZSIsImRhdGEiOiJub25lb2Z5b3VyYnVzaW5lc3MiLCJqdGkiOiJjOTAyM2MwNy00MDU5LTQ1MWEtOGY1Yy02OTQyZThhMmVjMWMiLCJpYXQiOjE1OTkwNzMyMjUsImV4cCI6MTU5OTA3NjgyNX0.4_ovCcUsHHPo62uNwhHTpLvjl8CXlGPD83QFqIGX6qE" "https://beta.walkingdocs.com/external/checklists" --compressed \
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