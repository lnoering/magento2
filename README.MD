<h1 align="center">lnoering/magento2</h1>

<div align="center">
  <p>Leonardo Noering - To improve the knowledge</p>
  <img src="https://img.shields.io/badge/knowlege-improve%20the%20knowledge-green" alt="Improve the knowledge" />
</div>

> Using this repo to improve the knowledge


## Table of contents

- [Install](#install)
- [Droplet server](#droplet-server)
- [Git](#git)
  - [Deploy](#deploy)
  - [Flow to work](#git-flow)
- [MTFT](#mtft)
- [Selenium](#selenium)
- [Frontend](#frontned)
    - Less
    - Grunt + Live Reload
    - New theme 
- [Debug](#debug)
- [CI](#ci)

## Install

- Use this command to install the first time.
```bash
bin/magento setup:install --base-url="http://localhost/" --db-host="db" --db-name="magento" --db-user="magento" --db-password="magento" --admin-firstname="admin" --admin-lastname="admin" --admin-email="user@example.com" --admin-user="admin" --admin-password="admin123" --language="en_US" --currency="USD" --timezone="America/Sao_Paulo" --use-rewrites="1" --backend-frontname="adminaccess" --opensearch-host="opensearch" --opensearch-port="9200" --opensearch-enable-auth="false" --opensearch-username="" --opensearch-password="" --base-url-secure="https://localhost/" --search-engine="opensearch" --session-save="redis" --session-save-redis-host="redis" --session-save-redis-port="6379" --session-save-redis-password="" --session-save-redis-timeout="2.5" --session-save-redis-persistent-id="" --session-save-redis-db="2" --session-save-redis-compression-threshold="2048" --session-save-redis-compression-lib="gzip" --session-save-redis-log-level="4" --session-save-redis-max-concurrency="6" --session-save-redis-break-after-frontend="5" --session-save-redis-break-after-adminhtml="30" --session-save-redis-first-lifetime="600" --session-save-redis-bot-first-lifetime="60" --session-save-redis-bot-lifetime="7200" --session-save-redis-disable-locking="0" --session-save-redis-min-lifetime="60" --session-save-redis-max-lifetime="2592000" --cache-backend="redis" --cache-backend-redis-server="redis" --cache-backend-redis-db="0" --page-cache="redis" --page-cache-redis-server="redis" --page-cache-redis-db="1"
```

-- URL SET
-- ADMIN USER
-- SEARCH
-- CACHE (Default caching, Page Cache, Session)

## Droplet Server

> Using [![DigitalOcean Referral Badge](https://web-platforms.sfo2.digitaloceanspaces.com/WWW/Badge%202.svg)](https://www.digitalocean.com/?refcode=720521a3104b&utm_campaign=Referral_Invite&utm_medium=Referral_Program&utm_source=badge) to run.

#### Creating droplet

- Create one droplet with centos 9.
- Access the console by web interface.
  - Droplets > [ Choice your droplet ] > Access > Recovery Console
- Change configs at ssh to accept login.
  - PermitRootLogin yes 
  - PasswordAuthentication yes
```bash
vi /etc/ssh/sshd_config
```
- Restart ssh service
```bash
service sshd restart
```
- Now you can access by ssh from your machine.

+ Will need create 4 droplets. 
  + PHP/NGINX OR APACHE
  + OPENSEARCH
  + DATABASE
  + REDIS (Session and code)

#### Installing the docker

- Update
```bash
sudo yum check-update
```

- Install
```bash
curl -fsSL https://get.docker.com/ | sh
```

- Start the docker
```bash
sudo systemctl start docker
```

- Check it's working
```bash
sudo systemctl status docker
```

- Enable to start the docker on reboot.
```bash
sudo systemctl enable docker
```

- I created one linux user to not use root every time. (I created the user web)
```bash
sudo usermod -aG docker web
```

#### Docker structure

- Copy the [markshust/docker-magento](https://github.com/markshust/docker-magento#existing-projects) existing projects.
```bash
curl -s https://raw.githubusercontent.com/markshust/docker-magento/master/lib/template | bash
```

## Git

- Install
```bash
sudo yum install git
```

- Config
```bash
git config --global user.name "Deployer"
git config --global user.email "lnoering@gmail.com"
```

### Deploy

- Run this commands at the server
```bash
mkdir /home/web/app/code
mkdir /home/web/app/code/magento.git
cd /home/web/app/code/magento.git
git init --bare
```

- Set the post-receive hook to git
```bash
mkdir /home/web/app/code/checkout
cd /home/web/app/code/magento.git/hooks
touch post-receive
chmod +x post-receive
vim post-receive
```

- Copy the data of post-receive from .configs/post-receive

* Server is done, now we will create the action at your local to push to the server.

- Creating one remote at your machine to deploy.
```bash
git remote add deploy ssh://web@dropletserver:22/home/app/code/magento.git
```

- The command to deploy. (we will use the master to deploy)
```bash
git push deploy master
```

### Git Flow

- Proccess to work with branchs 
  - [Branching-model](https://nvie.com/posts/a-successful-git-branching-model/)
  - [Git flow)](https://blog.betrybe.com/git/git-flow/)

## MTFT

To do

## Selenium

To do

## Frontend

To do

## Debug

To do

## CI

To do



*using the docker from - [markoshust/magento-nginx](https://github.com/markshust/docker-magento)