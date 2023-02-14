# Análise de dados em uma Tupla: Desenvolva um programa que leia quatro valores pelo teclado e guarde-os em uma tupla. No final, mostre:

a = int(input("Digite um número: "))
b = int(input("Digite outro número: "))
c = int(input("Digite mais um número: "))
d = int(input("Digite o último número: "))

tupla = (a, b, c, d)
tuplax = tupla
cont = 0
print (f"Você digitou os valores {tupla}")
for igual in tupla:
    if igual == 9:
        cont += 1
print (f"O valor 9 apareceu {cont} vezes")
if 3 in tupla:
    print(f"O número 3 apareceu na {tupla.index(3)+1}º posição")
else:
    print ("Não contêm número 3 na tupla")

county = 0
countx = 0

for tuplax in tupla:
    if tuplax % 2 == 0:
        county += 1
    else:
        countx += 1

print (f"Os valores pares digitados foram {county}")