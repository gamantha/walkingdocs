#!/bin/bash
var=$(date +"%FORMAT_STRING")
now=$(date +"%Y%m%d")
path = "/var/www/html/walkingdocs/walkingdocs/assets/checklists/temp"
curl "https://app.walkingdocs.com/api/v1.0/checklists/updated-since/1970-01-01T00:00:00.000Z" -H "authority: app.walkingdocs.com" -H "authorization: Bearer eyJraWQiOiI0aG9haHlIT3VBQWhpTlpZaXNGNUlRYmJodnd6Z3VDWWo1czhRRytBUXJNPSIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiI1ZDU5MzBlNS04MzY3LTQyZjMtOTZmMC03M2Q1MDBlOWUwNDMiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsImlzcyI6Imh0dHBzOlwvXC9jb2duaXRvLWlkcC5hcC1zb3V0aGVhc3QtMS5hbWF6b25hd3MuY29tXC9hcC1zb3V0aGVhc3QtMV9rUUtzSlpZc3giLCJjdXN0b206c3lzdGVtIjoie1wiaWRcIjpcIjU5Y2VkZmJhOWFlODBkMDU3NTdmNTRlOVwiLFwibmFtZVwiOlwiRGVtb1wifSIsInBob25lX251bWJlcl92ZXJpZmllZCI6ZmFsc2UsImNvZ25pdG86dXNlcm5hbWUiOiJyZW5vIiwiZ2l2ZW5fbmFtZSI6InJlbm8iLCJsb2NhbGUiOiJlbi11cyIsImN1c3RvbTpsb2NhdGlvbiI6IntcIm5hbWVcIjpcIkRlbW8gUG9saWtsaW5payBSU1VEXCIsXCJpZFwiOlwiNWI1NTQzNjBjN2I5MjQ0MmM1YjIxMjI2XCJ9IiwiYXVkIjoiMXA3dGUya2oyNXBycDhqajN1bmloaTk4cDMiLCJldmVudF9pZCI6ImQwOGNjOWNhLTk3ODEtNDEwYy1hZjAwLWI2ZDE3OTk0MDUyNSIsInRva2VuX3VzZSI6ImlkIiwiYXV0aF90aW1lIjoxNTgzODEwMTA1LCJwaG9uZV9udW1iZXIiOiIrNjI4NTQyNjczODI4IiwiZXhwIjoxNTgzODEzNzA1LCJjdXN0b206cGVybWlzc2lvbnMiOiJ7XCI1OWNlZGZiYTlhZTgwZDA1NzU3ZjU0ZTlcIjp7XCI1OWNlZGZiYTlhZTgwZDA1NzU3ZjU0ZTZcIjpbXCJMb2NhbEFkbWluXCIsXCJEb2N0b3JcIixcIk51cnNlXCIsXCJQaGFybWFjaXN0XCIsXCJQaGFybWFjeUFkbWluXCIsXCJSZWdpc3RyYXJcIixcIkJpbGxpbmdcIixcIkJpbGxpbmdBZG1pblwiLFwiRXh0ZXJuYWxSZXBvcnRpbmdcIixcIkV4dGVybmFsUmVwb3J0aW5nQWRtaW5cIl0sXCJyb2xlc1wiOltcIkJpbGxpbmdcIixcIlN5c3RlbUFkbWluXCIsXCJEb2N0b3JcIixcIk51cnNlXCIsXCJQaGFybWFjaXN0XCIsXCJQaGFybWFjeUFkbWluXCIsXCJSZWdpc3RyYXJcIixcIkJpbGxpbmdBZG1pblwiXX19IiwiaWF0IjoxNTgzODEwMTA1LCJmYW1pbHlfbmFtZSI6Indpam95byIsImVtYWlsIjoicmVub3dpam95b0BnbWFpbC5jb20ifQ.jfhcuov7hEexAjqCIiiXIqfKLsSCjv8wroyhpkKnRJ23jQT-eRTZNDi7BoE9948VxN7Fd-_NRQaulWG11v0lmVFfRLj-AVBgeyIjagv2GGvn2NV21EYvy8Q8C3zSj7li7rh8a_TULrENNy5Rfqzr5C5eZF8TBtMghCmV1dZHNL10aansdA8vPK4KCWiYcR0HYGWOWNRqCfgKxtoRea7ib6CJWMEr9A5eDIVbFOm4zvd4ndZhEXwOP2l1sZWqx0pFULI7nnbJYzn62vbasTeOXSP-sBtVmQClswXdgwqWBmj-j4c4Osp8LVUYd4BdT_uG-kmK68DSXfnDEC47a63aug" -H "sec-fetch-dest: empty" -H "wd-system: 59cedfba9ae80d05757f54e9" -H "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36" -H "wd-location: 5b554360c7b92442c5b21226" -H "accept: */*" -H "sec-fetch-site: same-origin" -H "sec-fetch-mode: cors" -H "referer: https://app.walkingdocs.com/checklist-reference" -H "accept-language: en-US,en;q=0.9,id-ID;q=0.8,id;q=0.7,th;q=0.6" -H "if-none-match: W/^\^"308a64-aTKDri7k4epYt13gi7ldUYjCYas^\^"" --compressed \
> "/var/www/html/walkingdocs/walkingdocs/assets/checklists/temp"
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