def menu(*opcoes):
    print('-' * 30)
    for i, opcao in enumerate(opcoes):
        print(f'{i+1} - {opcao}')
    print('-' * 30)

    while True:
        try:
            escolha = int(input('Escolha uma opção: '))
            if escolha < 1 or escolha > len(opcoes):
                print(f'\033[31mERRO: opção inválida! Digite um número entre 1 e {len(opcoes)}.\033[m')
            else:
                return escolha
        except ValueError:
            print('\033[31mERRO: por favor, digite um número inteiro válido.\033[m')
            
from menu import menu

while True:
    escolha = menu('Opção 1', 'Opção 2', 'Opção 3', 'Sair')
    if escolha == 1:
        # Executa a opção 1
        print('Opção 1 escolhida')
    elif escolha == 2:
        # Executa a opção 2
        print('Opção 2 escolhida')
    elif escolha == 3:
        # Executa a opção 3
        print('Opção 3 escolhida')
    elif escolha == 4:
        # Sai do programa
        print('Saindo do programa...')
        break
