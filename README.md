# CoFa

##Control de Facturacion

### Install Details

Clone the repo
Run "docker-compose up"

###PhpMyAdmin

```
docker run --name myadmin -d -e PMA_HOST=cofa_mysql -p 8081:80 --network cofa_cofa phpmyadmin/phpmyadmin
```

---

> Developed with :bulb: :headphones: :coffee: by [@armage](https://gitlab.com/armage)
