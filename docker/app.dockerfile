FROM node:14.19.0-buster

RUN apt update && apt -y upgrade
RUN apt -y install build-essential 

RUN npm install -g @vue/cli@4.5.15

EXPOSE 3000