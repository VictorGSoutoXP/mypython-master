# Faça um programa que leia a frase pelo teclado e mostre:
# Quantas vezes aparece a letra "A".
# Em que posição ela aparece a primeira vez.
# Em que posição ela aparece a última vez.

frase = str(input('Digite uma frase: ')).strip().upper()
print(f'A quantidade de ´A` nesta frase é de: {frase.count("A")}\n'
        f'O ultimo ´A` esta na posição: {frase.rfind("A")+1 - frase.count(" ")}\n'
         f'O primeiro ´A` esta na posição: {frase.find("A"[0])+1}')