#Crie um programa que tenha uma função fatorial() que receba dois parâmetros: o primeiro que indique o número a calcular e outro chamado show, que será um valor lógico (opcional) indicando se será mostrado ou não na tela o processo de cálculo do fatorial.
def fatorial(num, show=False):
    """
    Função que calcula o fatorial de um número e, se o parâmetro show for True, mostra o processo de cálculo.
    :param num: número inteiro a ser calculado o fatorial
    :param show: valor lógico que indica se será mostrado ou não o processo de cálculo (opcional, padrão é False)
    :return: fatorial do número passado como parâmetro
    """
    f = 1
    for i in range(num, 0, -1):
        f *= i
        if show:
            print(i, end='')
            if i > 1:
                print(' x ', end='')
            else:
                print(' = ', end='')
    return f


# testando a função com o show=False (padrão)
print(fatorial(5))  # saída: 120

# testando a função com o show=True
print(fatorial(5, show=True))  # saída: 5 x 4 x 3 x 2 x 1 = 120
