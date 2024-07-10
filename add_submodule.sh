#!/bin/bash

# Add the git submodule
git submodule add https://github.com/Kelvin-edgetech/payment.git payment
git submodule init
git submodule update

# Backup existing composer.json
cp composer.json composer.json.bak

# Modify composer.json
cat composer.json | \
    awk '
    BEGIN {
        require_found = 0;
        repositories_found = 0;
    }
    {
        # Add the required package
        if ($0 ~ /"require": {/) {
            require_found = 1;
            print $0;
            next;
        }

        if (require_found && $0 ~ /},/) {
            print "        \"kelvin-edgetech/payment\": \"dev-main\",";
            print $0;
            require_found = 0;
            next;
        }

        # Add the repositories entry
        if ($0 ~ /"repositories": \[/) {
            repositories_found = 1;
            print $0;
            next;
        }

        if (repositories_found && $0 ~ /\]/) {
            print "        {";
            print "            \"type\": \"path\",";
            print "            \"url\": \"payment\"";
            print "        },";
            print $0;
            repositories_found = 0;
            next;
        }

        print $0;
    }
    ' > composer.json.tmp

# Overwrite the original composer.json with the modified one
mv composer.json.tmp composer.json

# Run composer update
composer update

# Commit the changes
git add composer.json
git commit -m "Updated composer.json to include payment submodule"
git push origin main

echo "Submodule added and composer.json updated successfully."
