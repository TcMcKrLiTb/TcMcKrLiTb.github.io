# Ransomware Protection
Place this app in **owncloud/apps/**

[![Build Status](https://drone.owncloud.com/api/badges/owncloud/ransomware_protection/status.svg?branch=master)](https://drone.owncloud.com/owncloud/ransomware_protection)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/owncloud/ransomware_protection/badges/quality-score.png?b=master&s=51d416b6ab91ede5376eb6a27df16cad219f709b)](https://scrutinizer-ci.com/g/owncloud/ransomware_protection/?branch=master)

## Building the app

The app does not need to be built to be functional, however you can build it for the marketplace with

	make dist

## Using occ commands

### ransomguard:scan

Scan files for modifications after a provided timestamp. Syntax:

	sudo -u www-data php occ ransomguard:scan <timestamp> <user>

### ransomguard:restore

Restore files to state at a provided timestamp by reverting modifications which took place after timestamp. Syntax:

	sudo -u www-data php occ ransomguard:restore <timestamp> <user>

### ransomguard:lock

Lock write access for sync clients

	sudo -u www-data php occ ransomguard:lock <user>

### ransomguard:unlock

Unlock write access for sync clients

	sudo -u www-data php occ ransomguard:unlock <user>

## Running tests

In the ransomguard app directory run make test as HTTP user:

	sudo -u www-data make test
