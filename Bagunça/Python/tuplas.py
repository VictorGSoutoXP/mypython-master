#Mudei os nomes para uns mais simples (A,B,C)
dicionario = {'nome': ['Carolina', 'Ana', 'Beatriz'], 'idade': [1, 4, 5]}
print(dicionario)
# {'nome': ['Carolina', 'Ana', 'Beatriz'], 'idade': [1, 4, 5]}

#Atualizando a chave idade, baseado no que foi ordenado pela chave nome:
dicionario['idade'] = ([x for _, x in sorted(zip(dicionario['nome'], dicionario['idade']))])
print(dicionario)
#{'nome': ['Carolina', 'Ana', 'Beatriz'], 'idade': [4, 5, 1]}

#Por fim, atualizando a chave nome propriamente dita:
dicionario['nome'].sort()
print(dicionario)
#{'nome': ['Ana', 'Beatriz', 'Carolina'], 'idade': [4, 5, 1]}