# Exercício Python 043: Desenvolva uma lógica que leia o peso e a altura de uma pessoa, calcule seu Índice de Massa Corporal (IMC) e mostre seu status, de acordo com a tabela abaixo:
# - IMC abaixo de 18,5: Abaixo do Peso
# - Entre 18,5 e 25: Peso Ideal
# - 25 até 30: Sobrepeso
# - 30 até 40: Obesidade
# - Acima de 40: Obesidade Mórbida

sexo = int(input('''Qual seu sexo?
[1] HOMEM
[2] MULHER
R: '''))
print('utilize ponto')
peso = float (input('Peso (kg): '))
altura = float (input('Altura (metros):'))
imc = peso / (altura * altura)
# HOMEM
if sexo == 1:
    print('Seu imc {:.1f}'.format(imc))
    # ABAIXO DO PESO
    if imc <= 20.0:
        print('Você está abaixo do peso.\nO imc ideal é entre 21 à 24,9')
    # PESO IDEAL
    elif 21.0 <= imc <= 24.9:
        print('Você está no IMC ideal. Parabéns!')
    # OBSIDADE LEVE
    elif 25.0 >= imc <= 29.9:
        print('Você está com obsidade leve.\nO imc ideal é entre 21 à 24,9')
    # OBSIDADE MODERADA
    elif 30.0 >= imc <= 39.9:
        print ('Você está com obesidade moderada.\nO imc ideal é entre 21 à 24,9')
    elif imc >= 40.0:
        print('Você está com obesidade mórbida.\nO imc ideal é entre 21 à 24,9')
# MULHER
elif sexo == 2:
    print('Seu imc {:.1f}'.format(imc))
    # ABAIXO DO PESO
    if imc <= 19.0:
        print('Você está abaixo do peso.\nO imc ideal é entre 20 à 23,9')
    # PESO IDEAL
    elif 20.0 >= imc <= 23.9:
        print('Você está no IMC ideal. Parabéns!')
    # OBSIDADE LEVE
    elif 24.0 >= imc <= 28.9:
        print('Você está com obsidade leve.\nO imc ideal é entre 20 à 23,9')
    # OBSIDADE MODERADA
    elif 29.0 >= imc <= 39.9:
        print('Você está com obesidade moderada.\nO imc ideal é entre 20 à 23,9')
    elif imc >= 40.0:
        print('Você está com obesidade mórbida.\nO imc ideal é entre 20 à 23,9')

peso = float(input('Qual é o seu peso? (Kg) '))
altura = float(input('Qual é a sua altura? (m) '))
imc = peso / (altura ** 2)
print('O IMC dessa pessoa é de {:.1f}'.format(imc))

#Condições do IMC
if imc < 17:
    print('Muito abaixo do peso')
    print('O que pode acontecer?\nQueda de cabelo, infertilidade, ausência menstrual')
elif imc < 18.5:
    print('Abaixo do peso')
    print('O que pode acontecer?\nFadiga, stress, ansiedade')
elif imc < 25:
    print('Peso normal')
    print('O que pode acontecer?\nMenor risco de doenças cardíacas e vasculares')
elif imc < 30:
    print('Acima do peso')
    print('O que pode acontecer?\nFadiga, má circulação, varizes')
elif imc < 35:
    print('Obesidade Grau I')
    print('O que pode acontecer?\nDiabetes, angina, infarto, aterosclerose')
elif imc <= 40:
    print('Obesidade Grau II')
    print('O que pode acontecer?\nApneia do sono, falta de ar')
else:
    print('Obesidade Grau III')
    print('O que pode acontecer?\nRefluxo, dificuldade para se mover, escaras, diabetes, infarto, AVC')
