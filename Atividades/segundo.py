from email.errors import InvalidDateDefect


def new_func():
    nome = input ('Qual é o seu nome? ' )
    return nome

nome = new_func()
idade = input('Quantos anos você tem? ' )
peso = input('Qual é o seu peso? ')
print(nome, idade, peso)