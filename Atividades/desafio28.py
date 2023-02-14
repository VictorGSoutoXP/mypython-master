#Faça um programa que leia o nome completo de uma pessoa. mostrando em seguida o primeiro e o último nome separadamente. 
#Ex: Ana Maria de Souza 
#Primeiro = Ana
#Último = Souza
nome = str(input('Qual seu nome completo? ')).strip().split()
print(f'Seu primeiro nome é {nome[0]}. \nSeu último nome é {nome[-1]}.')