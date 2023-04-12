# Explicação do código:

# A função gerar_senha(tamanho) recebe um argumento tamanho que representa o número de caracteres da senha a ser gerada.
# A função define uma string caracteres que contém todos os caracteres possíveis para a senha. Neste exemplo, estamos usando as letras maiúsculas e minúsculas do alfabeto e os dígitos de 0 a 9.
# Usando um loop for, a função gera uma senha aleatória de tamanho tamanho escolhendo aleatoriamente um caractere da string caracteres em cada iteração e concatenando os caracteres escolhidos em uma string senha.
# A função retorna a senha gerada.
# Para usar essa função, basta chamar gerar_senha(tamanho) e passar o tamanho desejado da senha como argumento. No exemplo acima, é gerada uma senha de 8 caracteres e exibida na tela usando a função print().
# Criado por Victor Souto. :)

import random
import string

def gerar_senha(tamanho):
    # Define os caracteres possíveis para a senha
    caracteres = string.ascii_letters + string.digits

    # Gera uma senha aleatória usando os caracteres definidos
    senha = ''.join(random.choice(caracteres) for i in range(tamanho))

    return senha

# Exemplo de uso
senha_aleatoria = gerar_senha(16) # gera uma senha de 8 caracteres
print(senha_aleatoria)
