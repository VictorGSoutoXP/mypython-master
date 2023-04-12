#  Aprimore o desafio 93 para que ele funcione com vários jogadores, 
# incluindo um sistema de visualização de detalhes do aproveitamento de cada jogador.

jogadores = []

while True:
    jogador = {}
    jogador['nome'] = input('Nome do jogador: ')
    qtd_partidas = int(input(f'Quantas partidas {jogador["nome"]} jogou? '))

    gols_partida = []
    for i in range(qtd_partidas):
        gols_partida.append(int(input(f'Quantos gols na partida {i+1}? ')))

    jogador['gols'] = gols_partida
    jogador['total_gols'] = sum(gols_partida)
    jogadores.append(jogador)

    continuar = input('Deseja cadastrar outro jogador? (S/N) ').upper()
    if continuar == 'N':
        break

print('-=' * 30)
print(f'{"Código":<10} {"Nome":<15} {"Gols":<20} {"Total":<10}')
print('--' * 30)

for i, jogador in enumerate(jogadores):
    print(f'{i:<10} {jogador["nome"]:<15} {str(jogador["gols"]):<20} {jogador["total_gols"]:<10}')

while True:
    print('--' * 30)
    escolha = int(input('Mostrar dados de qual jogador? (999 para parar) '))
    if escolha == 999:
        break
    elif escolha >= len(jogadores):
        print(f'ERRO! Não existe jogador com código {escolha}. Tente novamente.')
    else:
        print(f'-- LEVANTAMENTO DO JOGADOR {jogadores[escolha]["nome"]}:')
        for i, gols in enumerate(jogadores[escolha]['gols']):
            print(f'   No jogo {i+1} fez {gols} gols.')
print('FIM DO PROGRAMA')
