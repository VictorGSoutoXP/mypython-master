# Criar um script derivado do cpf.py 
# Nome apenas aceita str
# Números aceitam apenas números
# for k,v in tel.items(): print(k, " - ", v) No código acima, declaramos 2 variáveis dentro da estrutura for, no caso, as variáveis k e v, a letra k vem de key e a letra v de value. Assim, temos que tanto a chave como também o valor são atribuido as variáveis a cada ciclo e então, podemos utiliza-las de maneira muito mais simples e prática.

# Melhorar explicação.
# Colocar dentro de uma função (Chamada de dados_do_aluno).
# Criar um dicionario com os dados finais, onde a chave é o nome da pessoa e o conteúdo é o retorno do dicionário dados que foi criado.
# Permitir que o usário coloque dados de mais alunos neste dicionário final.

dados = dict()
dados['Nome'] = str(input('Nome do aluno: '))
dados['Média'] = float(input('Média do aluno: '))
dados['Situação'] = 'Aprovado' if dados['Média'] >= 7 else 'Reprovado'
    for k, v in dados.items():
        print(f'{k} = {v}')





