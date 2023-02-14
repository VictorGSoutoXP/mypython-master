# Progressão arimética: lendo o primeiro termo e a razão de uma PA, mostrando os 10 primeiros termos da progressão usando a estrutura while.

primeiro = int(input("Digite um número: "))
razao = int(input("Digite a razão: "))
c = 1 # o contador começa com 1 pois a variável "primeiro" já é o primeiro termo.
print(primeiro, end=" - ")
while c < 10:
    c += 1
    primeiro += razao
    print(primeiro, end=" - ")
print("Fim!")