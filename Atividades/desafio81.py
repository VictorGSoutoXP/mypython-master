# Lista ordenada sem repetições: Crie um programa onde o usuário possa digitar cinco valores numéricos e cadastre-os em uma lista, já na posição correta de inserção (sem usar o sort()). No final, mostre a lista ordenada na tela.

lista = []
for c in range(0, 5):
    valor = int(input("Digite um valor: "))
    if c == 0:
        print("Valor adicionado ao final da lista")
        lista.append(valor)
    else:
        if valor <= min(lista):
            lista.insert(0, valor)
        elif valor >= max(lista):
            lista.insert(max(lista)+1, valor)
        elif max(lista) > valor > min(lista):
            for e, i in enumerate(lista):
                if valor > lista[e] and valor > lista[e+1] and valor > lista[e+2]:
                    lista.insert(e+3, valor)
                    break
                elif valor >= lista[e] and valor >= lista[e+1]:
                    lista.insert(e+2, valor)
                    break
                elif valor >= lista[e]:
                    lista.insert(e+1, valor)
                    break
    print(f"A lista escolhida possui os seguintos números: {lista}")