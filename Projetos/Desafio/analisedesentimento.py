# podemos utilizar a biblioteca nltk e o modelo de classificação NaiveBayesClassifier.

# Antes de começar, é necessário instalar a biblioteca nltk e baixar alguns recursos necessários, como o conjunto de dados vader_lexicon. Para isso, basta abrir um terminal ou prompt de comando e digitar os seguintes comandos:
# pip install nltk
# python -m nltk.downloader vader_lexicon
# Após instalar a biblioteca e baixar os recursos necessários, podemos criar o programa de análise de sentimentos em Python:

import nltk
from nltk.sentiment import SentimentIntensityAnalyzer

# Instanciando o analisador de sentimentos
sia = SentimentIntensityAnalyzer()

# Definindo o texto a ser analisado
texto = "Este filme é muito bom e recomendo a todos. A atuação dos atores é incrível!"

# Realizando a análise de sentimentos
sentimento = sia.polarity_scores(texto)

# Extraindo a pontuação de sentimento positivo, negativo e neutro
pontuacao_positiva = sentimento['pos']
pontuacao_negativa = sentimento['neg']
pontuacao_neutra = sentimento['neu']

# Verificando qual é o sentimento predominante
if pontuacao_positiva > pontuacao_negativa and pontuacao_positiva > pontuacao_neutra:
    print("Sentimento: positivo")
elif pontuacao_negativa > pontuacao_positiva and pontuacao_negativa > pontuacao_neutra:
    print("Sentimento: negativo")
else:
    print("Sentimento: neutro")

# Nesse exemplo, definimos um texto de exemplo e utilizamos o analisador de sentimentos para extrair as pontuações de sentimento positivo, negativo e neutro. Em seguida, verificamos qual é o sentimento predominante com base nas pontuações obtidas. O resultado da análise de sentimentos é impresso na tela.

# Vale lembrar que a análise de sentimentos é uma tarefa complexa e muitas vezes ambígua, e que os resultados obtidos podem variar dependendo do texto analisado e do modelo de classificação utilizado. É importante avaliar os resultados obtidos com cuidado e realizar testes com diferentes textos e modelos para avaliar a eficácia da análise de sentimentos.