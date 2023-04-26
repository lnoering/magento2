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
  - [Server Deploy Configs](#server-deploy-configs)
  - [Server Push Tag to Repository](#server-push-tag-to-repository)
  - [Local Configs to Deploy](#local-Configs-to-deploy)
  - [Deploy Command](#deploy-command)
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

## Server

<div align="center">
  <p>Digital Ocean</p>
  <a href="https://www.digitalocean.com/?refcode=720521a3104b&utm_campaign=Referral_Invite&utm_medium=Referral_Program&utm_source=badge" ><img src="https://web-platforms.sfo2.digitaloceanspaces.com/WWW/Badge%202.svg" alt="Digital Ocean" /></a>
</div>


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
- Now access by ssh from your machine.

+ Will need create 4 droplets. 
  + PHP/NGINX OR APACHE
  + OPENSEARCH
  + DATABASE
  + REDIS (Session and cache)

#### Server Configs

- Create the web user
```bash
useradd web
```
- Set the password to this user
```bash
passwd web
```

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

#### Docker access by internet

- Limit the access of services including the network.
```bash
networks:
  no-internet:
    driver: bridge
    internal: true
  internet:
    driver: bridge
```

  - I leave the network name internet just for the app (nginx).
  - The network name no-internet I added for all services.


- Droplets communications.
  - I used the Firewall from Digital Ocean panel to limit the access. (External Access)
    Creting sprecific rules to droplets.



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

### Server Deploy Configs

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

- Copy the data of post-receive from .configs/git bare/post-receive

### Server Push Tag to Repository

- Create one ssh-key at server (user web)
```bash
  ssh-keygen -t ed25519 -C "your_email@example.com"
```

- Add the key to the agent ssh. (not the .pub)
```bash
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/<key-created>
```

- Copy the pub key
```bash
cat ~/.ssh/<key-created>.pub
```

- Add to the github deploy key. (Enable the write)
  - https://github.com/\<repo-user\>/\<remo-name\>/settings/keys
  
    In my case:

  - https://github.com/lnoering/magento2/settings/keys

### Local Configs to Deploy

- Creating one remote at your machine to deploy.
```bash
git remote add deploy ssh://web@dropletserver:22/home/app/code/magento.git
```

### Deploy Command

- The command to deploy. (we will use the master to deploy)
```bash
git push deploy master
```

### Git Flow

<div align="center">
  <p>Git Flow</p>
  <img src="https://raw.githubusercontent.com/lnoering/magento2/master/.configs/git-flow-model.webp" width="524" height="695" alt="Flow" />
</div>


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