# GiveawayD - create your own Giveaways

## Description

GiveawayD is a website aimed to be useful when creating giveaways. (In the future) It will also feature a discord bot, which allows the integration between the official website (more <a href="#own"> here <a>) and discord.


## Requirements

* PHP 7.4
* Apache 2.4
* mariaDB

You need any linux machine (system tested on Debian 10 and XAMPP), 8GB RAM and a network connectivity is needed.

## Installation

* clone the repository via `git clone https://github.com/Ente/giveawayd.git` to the machine
* configure the `api/inc/app.ini` to the real values, more information inside the file
* import the `setup.sql` into your mariaDB/mysql server
* open your browser and visit the website, you can be prompted to create a account. If you have an id, you also get a automatically created tiny url, which you can access like `https://[ip-or-fqdn]/g/{id}`.
* Information about the administrative area can be found in the next part.

## Administrative Area

### Info

In this tab you can optain a few informations about the installation and version, time, but also a little statistics about the site.PP
You can find informations about the total visists, total giveaways, total participants, all accounts and a few more.

This can be useful for monitoring aswell, since it also shows the server cpu and ram usage each time you reload, but can be modified in the <a href="#configuration"> Configurations </a> tab.

### User control

Here you can find every account registered on the website, but you cannot see their email, country or full username. You only see their name without the descriminator ("#XXXX").
You can ban accounts or disable and delete them. You cannot really change any information here without going to to that on the database.

This feature will get a few updates within the next versions

### Site control

Here you can control the flow of the website, you can disable certain areas if you are going to <a href="#code-changes"> make changes to the code </a>.
Or if you are just planing to do an maintenance.

Here you can also change the name, footer, Terms of Service & Privacy Policy URL.

--------

This website stores the username, email, id and the locale of the user. No passwords or any other authentications are stored.
You can delete your account when using the `panel`.

All login information is gone after the browser session has been closed.

<h2 id="code-changes">Make change to the code</h2>

You can either add your own plugins through the <a href="#plugins">plugin system</a> or by just editing by hand. Be careful to read the <a href="https://giveawayd.theducky.xyz/docs/code-docs">Code Documentation</a>
