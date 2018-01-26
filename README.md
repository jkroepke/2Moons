# SteemNova - 2Moons engine-based browsergame for Steemians by steemnova

![](https://steemitimages.com/DQmNhKvcRhp5THpijqS45M18MiDpg1Cvc78Sv9rKCiJi5NJ/image.png)


## The game

The open source browsergame framework is based on [2Moons](https://gitter.im/2MoonsGame/Lobby/).

Full source code is placed at [github.com/steemnova/steemnova](https://github.com/steemnova/steemnova) repository. It is fork of [jkroepke/2Moons](https://github.com/jkroepke/2Moons) for Steem community purposes. SteemNova repository is the center of the game. The opportunity was given to change the game code by Steemians, most probably [Utopians](https://utopian.io/) as a contribution. There are many things to modify starting from **graphics, languages, code improvements up to Steem integration and bughunting**.

<center>![](https://www.steem.center/images/archive/5/55/20160814202358%21Steem_Logo.png)</center>


## Roadmap

SteemNova expansion goes as follows:
1. ~~Reorganize github code. Specify README and LICENSE documentation~~. Fix any game issues if there will be any.
2. Create SteemNova Board community on top of Steem blockchain.
3. Game manual and tips & tricks for newbies.
4. Specify detailed explanation how the reward system will work.
5. Announce bug bounties, artwork contests and utopian-io task requests for contributors (mobile UI, visual bugs etc.).
6. Steem accounts integration.


## Local installation

- Clone the repo: `git clone https://github.com/steemnova/steemnova`
- Install components: `apt-get install apache2 php7.0 php7.0-gd php7.0-fpm php7.0-mysql libapache2-mod mysql-server`
- Setup mysql: `create user USER identified by PASSWORD; create database DB; grant all privileges on DB.* to USER;`
- Set write privileges to dirs: `cache/`, `includes/`
- Run wizard: `127.0.0.1/install/install.php`


## Copyright and license

SteemNova is a fork of Open Source Browsergame Framework [jkroepke/2Moons](https://github.com/jkroepke/2Moons) engine.

Code copyright 2009-2016 Jan-Otto Kröpke released under the MIT License. 

Code copyright 2018 @steemnova released under the MIT License.