# Crie um programa que tenha uma função chamada voto() que vai receber como parâmetro o ano de nascimento de uma pessoa.
# Retornando um valor literal indicando se uma pessoa tem voto NEGADO, OPCIONAL e OBRIGATÓRIO nas eleições.

def voto(ano):
    from datetime import date
    idade = date.today().year - ano
    if idade < 16:
        return 'NEGADO'
    elif 16 <= idade < 18 or idade >= 70:
        return 'OPCIONAL'
    else:
        return 'OBRIGATÓRIO'

# Exemplo de uso da função
ano_nascimento = int(input('Digite o ano de nascimento: '))
print(f'Com {date.today().year - ano_nascimento} anos o voto é {voto(ano_nascimento)}')

