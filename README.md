
# rabbitmq-php-worker

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
                    "containerPath": "/app",
                    "hostPath": "[repertoire_application]",
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

## Variables d'environnement

### RABBITMQ_HOST

Adresse du serveur RabbitMQ

### RABBITMQ_PORT

Port du serveur RabbitMQ (5672 par défaut)

### RABBITMQ_USER

Nom d'utilisateur du serveur RabbitMQ (guest par défaut)

### RABBITMQ_PASS

Mot de passe du serveur RabbitMQ (guest par défaut)
