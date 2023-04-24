# Para criar um programa em Python que use aprendizado de máquina para reconhecer imagens e classificá-las em diferentes categorias, podemos usar uma biblioteca de aprendizado de máquina chamada TensorFlow. O TensorFlow é uma biblioteca de código aberto criada pela Google para construir e treinar modelos de aprendizado de máquina.

# Para este exemplo, vamos criar um modelo que possa classificar imagens em duas categorias: gato e cachorro.

# Passo 1: Instalar o TensorFlow
# Para instalar o TensorFlow, basta usar o gerenciador de pacotes pip. Abra um terminal e digite o seguinte comando:
# pip install tensorflow

# Passo 2: Preparar os dados
# O primeiro passo é preparar os dados para o modelo. Para isso, precisamos ter um conjunto de dados com imagens de gatos e cachorros. Podemos usar a biblioteca Keras para carregar um conjunto de dados pré-existente.

from tensorflow.keras.datasets import cifar10

(train_images, train_labels), (test_images, test_labels) = cifar10.load_data()

# Passo 3: Pré-processamento dos dados
# O próximo passo é pré-processar os dados. Isso significa que precisamos normalizar as imagens para que todas elas tenham a mesma escala de valores de pixels. Além disso, também precisamos converter as labels de texto para números.

import numpy as np

train_images = train_images.astype('float32') / 255
test_images = test_images.astype('float32') / 255

train_labels = np.array(train_labels == 3).astype(np.int32)
test_labels = np.array(test_labels == 3).astype(np.int32)

# Neste exemplo, estamos convertendo as imagens para terem valores entre 0 e 1 e as labels estão sendo convertidas para 0 (cachorro) ou 1 (gato).

# Passo 4: Construir o modelo
# Agora podemos construir o modelo. Vamos usar uma arquitetura simples com uma camada de convolução, uma camada de pooling e uma camada densa.

from tensorflow.keras import models, layers

model = models.Sequential()
model.add(layers.Conv2D(32, (3, 3), activation='relu', input_shape=(32, 32, 3)))
model.add(layers.MaxPooling2D((2, 2)))
model.add(layers.Flatten())
model.add(layers.Dense(1, activation='sigmoid'))

# Passo 5: Compilar o modelo
# Após a construção do modelo, precisamos compilá-lo. Isso envolve a escolha de uma função de perda e um otimizador.

model.compile(optimizer='rmsprop', loss='binary_crossentropy', metrics=['accuracy'])

# Passo 6: Treinar o modelo
# Agora podemos treinar o modelo. Vamos usar os dados de treinamento que preparamos anteriormente.

model.fit(train_images, train_labels, epochs=10, batch_size=64)

# Passo 7: Avaliar o modelo
# Por fim, podemos avaliar o modelo usando os dados de teste.

test_loss, test_acc = model.evaluate(test_images, test_labels)

print('Test accuracy:', test_acc)

# O código completo fica:

import numpy as np
from tensorflow.keras.datasets import cifar10
from tensorflow.keras import models, layers

(train_images, train_labels), (test_images, test_labels) = cifar10.load_data()

train




