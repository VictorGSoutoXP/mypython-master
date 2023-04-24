# Crie uma conta de desenvolvedor no Twitter e crie um aplicativo. Você precisará de credenciais de acesso do Twitter para poder enviar tweets pelo seu bot.

# Instale a biblioteca Tweepy no seu ambiente de desenvolvimento. Tweepy é uma biblioteca Python para acesso à API do Twitter.

# Crie um arquivo Python e importe a biblioteca Tweepy. Certifique-se de ter suas credenciais de acesso do Twitter à mão.

# Crie uma função que gera um tweet aleatório a partir de uma lista de frases. Você pode criar sua própria lista ou encontrar uma lista na internet. Certifique-se de que a função retorna uma única frase escolhida aleatoriamente.

# Crie uma função que envia um tweet usando a função da biblioteca Tweepy. A função deve aceitar o texto do tweet como um argumento e enviar o tweet para a conta do Twitter do bot.

# Crie um loop principal que execute indefinidamente. O loop deve chamar a função de geração de tweets aleatórios e a função de envio de tweets em um intervalo de tempo definido pelo usuário.

# Teste o seu bot de Twitter e certifique-se de que ele esteja funcionando corretamente. Você pode executar o bot localmente ou implantá-lo na nuvem, como no Heroku.


import tweepy
import time
import random

consumer_key = 'sua chave do Twitter'
consumer_secret = 'sua chave secreta do Twitter'
access_token = 'seu token de acesso do Twitter'
access_token_secret = 'seu token secreto de acesso do Twitter'

# Autenticação com o Twitter
auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_token_secret)

# Criação do objeto da API
api = tweepy.API(auth)

# Lista de frases aleatórias
frases = [
    'Estou aprendendo Python hoje!',
    'Que dia bonito hoje, não é mesmo?',
    'Eu adoro programar!',
    'O Python é a melhor linguagem de programação!',
]

# Função para gerar um tweet aleatório
def gerar_tweet():
    return random.choice(frases)

# Função para enviar um tweet
def enviar_tweet(tweet):
    api.update_status(tweet)

# Loop principal
while True:
    tweet = gerar_tweet()
    enviar_tweet(tweet)
    time.sleep(3600)  # intervalo de uma hora

# Neste exemplo, o bot envia um tweet aleatório a cada hora. Você pode personalizar a lista de frases e o intervalo de tempo para atender às suas necessidades. Lembre-se de que é importante seguir as diretrizes do Twitter ao criar um bot e não violar os termos de serviço do Twitter.