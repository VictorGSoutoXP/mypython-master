# Crie um programa que tenha a função leiaInt(), que vai funcionar de forma semelhante 'a função input() do Python.
# só que fazendo a validação para aceitar apenas um valor numérico. Ex: n = leiaInt('Digite um n: ')
def leiaInt(msg):
    while True:
        try:
            n = int(input(msg))
        except (ValueError, TypeError):
            print('\033[31mERRO: por favor, digite um número inteiro válido.\033[m')
            continue
        else:
            return n

# Exemplo de uso da função leiaInt():
n = leiaInt('Digite um número inteiro: ')
print(f'Você acabou de digitar o número {n}.')
