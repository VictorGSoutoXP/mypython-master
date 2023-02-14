# Tuplas com time de Futebol: Crie uma tupla preenchida com os 20 primeiros colocados da Tabela do Campeonato Brasileiro de Futebol, na ordem de colocação. Depois mostre: a) Os 5 primeiros times.

print('='*100)
print(' '*100)

times = ('Corinthians','Palmeiras','Santos','Grêmio','Cruzeiro','Flamengo','Vasco','Chapecoense',
'Atlético','Botafogo','Atlético-PR','Bahia','São Paulo','Fluminense','Sport Recife','EC Vitória',
'Curitiba','Avaí','Ponte preta','Atlético-GO')

print('''\033[31m[1]\033[m OS 5 PRIMEIROS TIMES
\033[31m[2]\033[m OS ÚLTIMOS 4 COLOCADOS 
\033[31m[3]\033[m TIMES EM ORDEM ALFABÉTICA
\033[31m[4]\033[m EM QUE POSIÇÃO ESTÁ O TIME DA CHAPECOENSE
\033[31m[5]\033[m SAIR''')

cont1 = 1
cont2 = 20

while True:
    print(' '*100)
    esc = int(input('Escolha qual parte do menu você quer acessar \033[31m[DE 1 A 5]\033[m: '))
    print(' '*100)
    if esc == 1:
        for c in range(0,5):
            print(f'{cont1}º colocado: {times[c]}')
            cont1 += 1
    elif esc == 2:
        for c in range(1,6):
            print(f'{cont2}º colocado: {times[-c]}')
            cont2 -= 1 
    elif esc == 3:
        sor = sorted(times)
        print(f'Times em ordem alfabética: {sor}')
    elif esc == 4:
        ind = times.index('Chapecoense')
        print(f'O time da Chapecoense está na \033[31m{ind+1}º\033[m posição')
    elif esc == 5:
        break
    else:
        print('\033[31mTENTE NOVAMENTE\033[m')
print(' '*100)
print('FIM')
print(' '*100)
print('='*100)