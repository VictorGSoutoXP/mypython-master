# Faça um programa que tenha uma função chamada ficha(), que receba dois parâmetros opcionais: o nome de um jogador e quantos gols ele marcou.
# O programa deverá ser capaz de mostrar a ficha do jogador, mesmo que algum dado não tenha sido informado corretamente.
def ficha(nome='<desconhecido>', gols=0):
    print(f'O jogador {nome} fez {gols} gol(s) no campeonato.')

# Exemplo de uso da função ficha():
ficha('João', 5) # saída: O jogador João fez 5 gol(s) no campeonato.
ficha('Maria') # saída: O jogador Maria fez 0 gol(s) no campeonato.
ficha() # saída: O jogador desconhecido fez 0 gol(s) no campeonato.
