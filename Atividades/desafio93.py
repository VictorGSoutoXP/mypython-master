# Crie um programa que gerencie o aproveitamento de um jogador de futebol. 
# O programa vai ler o nome do jogador e quantas partidas ele jogou. 
# Depois vai ler a quantidade de gols feitos em cada partida.
# No final, tudo isso será guardado em um dicionário, incluindo o total de gols feitos durante o campeonato.
jogador = {}

jogador['nome'] = input('Nome do jogador: ')
partidas = int(input(f'Quantas partidas {jogador["nome"]} jogou? '))

gols = []
total_gols = 0

for partida in range(1, partidas+1):
    gols_partida = int(input(f'Quantos gols na partida {partida}? '))
    gols.append(gols_partida)
    total_gols += gols_partida

jogador['gols'] = gols
jogador['total_gols'] = total_gols

print('-=' * 30)
print(jogador)
