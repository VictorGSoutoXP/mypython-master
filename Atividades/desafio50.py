#  Mostrando a tabuada de um número que o usuário escolher, só que agora utilizando um laço for.

print("""
[1] adição
[2] subtração
[3] multiplicação
[4] divisão
Escolha a opção para a tabuada:""")
a = int(input())
if a == 1:
    print("Adição")
    b = int(input("Escolha um numero para o calculo: "))
    for c in range(0,11,1):
        print(b, "+", c, "= ", (b+c))
elif a == 2:
    print("Subtração")
    b = int(input("Escolha um numero para o calculo: "))
    for c in range(0,11,1):
        print(b, "-", c, '= ', (b-c))
elif a == 3:
    print("Multiplicação")
    b = int(input("Escolha um numero para o calculo: "))
    for c in range(0, 11, 1):
        print(b, "x", c, '= ', (b*c))
elif a == 4:
    print("Divisão")
    b = int(input("Escolha um numero para o calculo: "))
    for c in range(1, 11, 1):
        print(b, "/", c, '= ', '{:.2f}'.format(b/c))