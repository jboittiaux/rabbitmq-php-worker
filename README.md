
# **rabbitmq-php-worker**

----------

## Mise en place du worker sur marathon

    {
        "id": "id_application",
        "cmd": null,
        "cpus": 0.2,
        "mem": 128,
        "disk": 0,
        "instances": 0,
        "container": {
            "type": "DOCKER",
            "volumes": [
                {
                    "containerPath": "/app/composer.json",
                    "hostPath": "[repertoire_application]/composer.json",
                    "mode": "RW"
                },
                {
                    "containerPath": "/app/process.php",
                    "hostPath": "[repertoire_application]/process.php",
                    "mode": "RW"
                }
            ],
            "docker": {
                "image": "jboittiaux/rabbitmq-php-worker:develop",
                "network": "BRIDGE",
                "privileged": false,
                "parameters": [],
                "forcePullImage": false
            }
        },
        "env": {
            "RABBITMQ_HOST": "192.168.12.113",
            "RABBITMQ_PORT": 5672,
            "RABBITMQ_USER": "guest",
            "RABBITMQ_PASS": "guest"
        }
    }

----------

## Variables d'environnement

#### **RABBITMQ_HOST** [required]

Adresse du serveur RabbitMQ

#### **RABBITMQ_PORT**

Port du serveur RabbitMQ (5672 par défaut)

#### **RABBITMQ_USER**

Nom d'utilisateur du serveur RabbitMQ (guest par défaut)

#### **RABBITMQ_PASS**

Mot de passe du serveur RabbitMQ (guest par défaut)

#### **RABBITMQ_QUEUE** [required]

Queue de traitement du serveur RabbitMQ

----------

## Mise en place de l'applicatif

Par défaut, le conteneur contient une application qui va se contenter d'afficher les messages de la queue de traitement.
Pour définir le code de traitement du worker, il suffit de surcharger le fichier `/app/process.php`.

    <?php

    use PhpAmqpLib\Message\AMQPMessage;

    function process_message(AMQPMessage $message)
    {
        /* CODE ICI */
    }

Si certaines librairies doivent être intégrée dans le code du worker, il est possible de surcharger le fichier `/app/composer.json`.

**Attention** : à minima, le fichier `/app/composer.json` doit contenir les librairies suivantes

    {
        "require": {
            "php-amqplib/php-amqplib": "^2.7",
            "pimple/pimple": "^3.2"
        }
    }
