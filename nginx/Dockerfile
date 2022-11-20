FROM nginx:stable-alpine

RUN  touch /var/run/nginx.pid && \
     chown -R nginx:nginx /var/cache/nginx /var/run/nginx.pid

WORKDIR /nginx

RUN chown nginx:nginx /nginx

USER nginx

COPY ./conf /nginx/conf

CMD ["nginx", "-c", "/nginx/conf/nginx.conf"]