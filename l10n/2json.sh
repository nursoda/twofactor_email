#!/bin/bash
for i in l10n/*.js
do
	echo $i → ${i}on
	grep -vE '^\s+/|^$' $i|sed -zE 's/OC.L10N.register\(\s*"twofactor_email",\s+\{/{"generated_–_use_xx.js_instead!":"","translations":{/'|sed -zE 's/,\s+\},\s+""\);/\n},"pluralForm":""}/'| jq -c > ${i}on
done
