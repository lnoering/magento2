<h1 align="center">lnoering/magento2</h1>

<div align="center">
  <p>Leonardo Noering - To improve the knowledge</p>
  <img src="https://img.shields.io/badge/knowlege-improve%20the%20knowledge-green" alt="Improve the knowledge" />
</div>

> Using this repo to improve the knowledge


## Table of contents

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

### Deploy

- Process to deploy

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