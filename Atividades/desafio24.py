# Faça um programa que leia um número de 0 a 9999 e mostre na tela cada um dos digitos separados 
# ex: digite um número 1834 unidade 4 dezenas: 3 centenas:8 milhar:1

n = input("Número: ")
variavel = 4-len(n)
novo = n.replace(n, "0"*variavel+n)
print("Unidade: ", novo[3])
print("Dezena: ", novo[2])
print("Centena: ", novo[1])
print("Milhar: ", novo[0])
