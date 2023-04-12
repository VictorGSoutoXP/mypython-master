#  Crie um módulo chamado moeda.py que tenha as funções incorporadas aumentar(), diminuir(), dobro() e metade(). Faça também um programa que importe esse módulo e use algumas dessas funções.
import moeda

valor = float(input('Digite um valor: '))
taxa = float(input('Digite uma taxa em porcentagem: '))

valor_aumentado = moeda.aumentar(valor, taxa)
valor_diminuido = moeda.diminuir(valor, taxa)
valor_dobrado = moeda.dobro(valor)
valor_metade = moeda.metade(valor)

print(f'Valor original: R${valor:.2f}')
print(f'Valor aumentado em {taxa:.2f}%: R${valor_aumentado:.2f}')
print(f'Valor diminuído em {taxa:.2f}%: R${valor_diminuido:.2f}')
print(f'Dobro do valor: R${valor_dobrado:.2f}')
print(f'Metade do valor: R${valor_metade:.2f}')
