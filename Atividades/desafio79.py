# Maior e menor valores na lista: Faça um programa que leia 5 valores numéricos e guarde-os em uma lista. No final, mostre qual foi o maior e o menor valor digitado e as suas respectivas posições na lista. 

valores = []
for c in range(0, 5):
    valores.append(int(input(f"Digite um valor para a posição {c}: ")))
print("=-"*30)
print(f"Você digitou os valores: {valores}")
print(f"O menor valor digitado foi o {min(valores)} na posição {valores.index(min(valores))}.")
print(f"O maior valor digitado foi o {max(valores)} na posição {valores.index(max(valores))}.")