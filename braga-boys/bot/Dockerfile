FROM node:alpine

ENV LANG="C.UTF-8" PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true

RUN apk update && \
    apk add --no-cache zlib-dev udev nss ca-certificates chromium && \
    adduser -h /home/bot -D -u 10086 bot && \
    yarn cache clean && \
    rm -rf /tmp/* /etc/apk/* /var/cache/apk/* /usr/share/man

WORKDIR /home/bot

COPY ./package.json .

RUN npm i -g npm-check-updates && \
    ncu -u && \
    npm install 

COPY ./views ./views
COPY bot.js .
COPY index.js .

USER bot

CMD ["node", "/home/bot/index.js"]
