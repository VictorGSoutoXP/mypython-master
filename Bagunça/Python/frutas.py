
# Para criar um novo dicionário as informações devem ser passadas entre chaves {}. As quais devem seguir a estrutura de pares chave: valor. Normalmente denotada na literatura pelos termos em inglês como key:value. Um dicionário pode ser criado sem nenhum conteúdo, como por exemplo a variável preco_frutas na linha abaixo. Observe que mesmo não atribuindo nenhum dado para estrutura o Python reconhece-a como uma variável da classe dict, ou seja, dicionário.
preco_fruta = {}
type(preco_fruta)
dict
# A inicialização pode ser realizada através da atribuição direta à variável. Os valores repassados devem estar entre as chaves podendo ser tanto inteiros como strings, como mostra exemplo abaixo:
preco_frutas = {'pera':'Estava mais cara que o normal...', #Inicializando o dicionário somente com strings
                'uva': 'Estava bem conta!',
                'maçã': 'Não tinha...!'}
numero_frutas = {1: 1, 2:1, 3:0} #Somente com inteiros
frutas = {'pera': 50, 'uva': 2, 'maçã':55, 'abacaxi': 25, 'manga':''} #Misturando os dois tipos
print(preco_frutas)
print(numero_frutas)
print(frutas)
{'pera': 'Estava mais cara que o normal...', 'uva': 'Estava bem conta!', 'maçã': 'Não tinha...!'}
{1: 1, 2: 1, 3: 0}
{'pera': 50, 'uva': 2, 'maçã': 55, 'abacaxi': 25, 'manga': ''}
# Na primeira linha o dicionário preco_frutas é inicializado com uma sequência de valores entres chaves. Internamente os elementos são definidos utilizando a estrutura key:value (chave: valor) separados por vírgula. Conforme mostra a linha 2, o dicionário numero_frutas utiliza somente inteiros para inicializar a estrutura. Assim como, na terceira linha os dois tipos de dados são misturados não necessitando realizar nenhum tipo de conversão de dados. É possível criar uma chave e não inicializa-la deixando-a em branco, como acontece no dicionário de frutas na chave manga. Nas linhas subsequentes são realizadas as impressões dos três dicionários criados.
# Uma vez que o dicionário foi populado, o acesso aos itens ou elementos pode ser realizado de modo similar ao método de acesso das listas. Entretanto, aqui deve-se passar a chave para qual se deseja acessar o valor, conforme mostra a linha 2. Ou ainda, através da função get() como mostra a linha 4, a qual pode ter o retorno da função atribuída a uma variável ou ser chamada diretamente na função print.
frutas = {'pera': 50, 'uva': 2, 'maçã':55, 'abacaxi': 25}
print(frutas['pera'])
print(frutas['uva'])
qtd_macas = frutas.get('maçã')
print('O Total de maçãs é: ',qtd_macas)
print('O Total de maçãs é: ',frutas.get('maçã'))
50
2
# O Total de maçãs é:  55
# O Total de maçãs é:  55
# Os valores podem ser atribuídos diretamente a uma chave específica, isso pode ocorrer quando é necessário alterar atualizar ou inicializar uma chave do dicionário. Nas linhas abaixo, temos um exemplo de inicialização com números inteiros nas duas primeiras linhas, e na linha 3 uma string foi atribuída. Ou seja, o mesmo processo que ocorre na inicialização quando não existe nenhuma chave, pode ser utilizado em um dicionário que já contenha um ou mais itens.
frutas['laranja'] = 0
frutas['abacate'] = 33
frutas['abacate'] = 'Comprar dois...' 
frutas
{'pera': 50,
 'uva': 2,
 'maçã': 55,
 'abacaxi': 25,
 'laranja': 0,
 'abacate': 'Comprar dois...'}
 # A operação de deleção pode ser realizada tanto para uma chave específica, como a remoção do dicionário inteiro. Na segunda linha, a chave 'abacate' é removida com o comando del, conforme mostra a impressão na linha 3. Na linha 4, é criado o dicionário teste, o qual tem impresso o valor na linha 5 e logo em seguida todo o dicionário é removido. Por fim, tem-se uma tentativa de impressão, porém é exibida uma mensagem de erro informando que o dicionário não foi encontrado devido a remoção.

print(frutas)
del frutas['abacate']
print(frutas)
teste = {'um':1}
print(teste)
del teste
print(teste)
{'pera': 50, 'uva': 2, 'maçã': 55, 'abacaxi': 25, 'laranja': 0, 'abacate': 'Comprar dois...'}
{'pera': 50, 'uva': 2, 'maçã': 55, 'abacaxi': 25, 'laranja': 0}
{'um': 1}
'''
---------------------------------------------------------------------------

NameError                                 Traceback (most recent call last)
<ipython-input-36-ce93d9efffe7> in <module>
      6 print(teste)
      7 del teste
----> 8 print(teste)

NameError: name 'teste' is not defined
# Para deletar todas as chaves e valores de um dicionário, pode ser utilizada a função clear() ou ainda atribuir duas chaves vazias ({}) ao nome do dicionário. Como mostra o exemplo abaixo:
cesta_frutas = {'pera':10, 'uva':2, 'maça':55, 'abacaxi':25, 'laranja':15}
print(cesta_frutas)
cesta_frutas.clear()
print(cesta_frutas)
cesta_frutas = {}
{'pera': 10, 'uva': 2, 'maça': 55, 'abacaxi': 25, 'laranja': 15}
{} '''
# Com a função popitem() também é possível deletar os elementos do dicionário, quando executada, o último item será removido. No exemplo abaixo, a primeira linha mostra o dicionário com todos os elementos. Na segunda linha o comando é executado, em seguida a impressão é realizada sem o último item.
print(preco_frutas)
preco_frutas.popitem()
print(preco_frutas)
{'pera': 'Estava mais cara que o normal...', 'uva': 'Estava bem conta!', 'maçã': 'Não tinha...!'}
{'pera': 'Estava mais cara que o normal...', 'uva': 'Estava bem conta!'}
# Um dicionário pode conter vários itens, e como mencionado esses itens podem ser tanto inteiros ou strings. Uma vez que a cesta de frutas esta criada, é preciso visualizar o conteúdo da cesta. Para executar essa tarefa existem diferentes formas com resultados parecidos. Uma das formas mais básicas e forma mais comum e muito utilizada em Python, é a impressão através da função print, necessitando apenas passar o nome do dicionário. Como mostra o exemplo nas linhas abaixo.
cesta_frutas = {'pera':10, 'uva':2, 'maça':55, 'abacaxi':25, 'laranja':15}
print(cesta_frutas)
{'pera': 10, 'uva': 2, 'maça': 55, 'abacaxi': 25, 'laranja': 15}    
# Os dicionários são iteráveis, ou seja, são objetos que podem ter os elementos da sequência percorridos um a um. Outros tipos que dispõem dessa funcionalidade são: listas, strings, tuplas e conjuntos. Em Python, comando for contém um iterador que é responsável por passar por cada um dos elementos e executar alguma operação. O método items() retorna uma lista de tuplas contendo as chaves e seus respectivos valores, como mostra a linha abaixo.
print(cesta_frutas.items())
dict_items([('pera', 10), ('uva', 2), ('maça', 55), ('abacaxi', 25), ('laranja', 15)])
# Entretanto, essa forma de visualização pode não ser muito apresentável. Uma forma, mas interessante é utilizar o comando for para realizar a impressão. Ou seja, cada elemento será iterado e terá o valor atribuído as variáveis fruta e qtd, definidas no corpo do comando. A variável fruta recebe chave, enquanto a variável qtd o valor associado a cada chave. Ou seja, o comando acessa a lista, pega o primeiro elemento que contém uma tupla e a quebra em duas partes, atribuindo respectivamente a cada uma das variáveis e realiza a impressão. Esse processo ocorre até que todos os elementos tenham sido percorridos e a lista esteja vazia.

for fruta, qtd in cesta_frutas.items():
    print(fruta +": "+str(qtd))
pera: 10
uva: 2
maça: 55
abacaxi: 25
laranja: 15
# O método keys() também retorna uma lista, entretanto essa lista contém somente as chaves do dicionário, desprezando assim a impressão dos valores associados a cada chave.

print(cesta_frutas.keys())
dict_keys(['pera', 'uva', 'maça', 'abacaxi', 'laranja'])
# Na linha abaixo, é realizada a impressão de cada uma das chaves contidas na lista, através do comando for.

for fruta in cesta_frutas.keys():
    print(fruta)
pera
uva
maça
abacaxi
laranja
# Por sua vez, o método values() retorna uma lista contendo os valores, desprezando assim as chaves do dicionário.

print(cesta_frutas.values())
dict_values([10, 2, 55, 25, 15])
# Sendo possível também, realizar a iteração sobre cada um dos elementos, como mostra a linha abaixo.

for fruta in cesta_frutas.values():
    print(fruta)
10
2
55
25
15
# Um detalhe a ser observado é que a impressão dos elementos de um dicionário obedece à ordem que foram inseridos. Ou seja, para realizar a impressão de modo ordenado, utiliza-se a função sorted(). Ordenando a lista em ordem alfabética, conforme a linha abaixo.

sorted(cesta_frutas.keys())
['abacaxi', 'laranja', 'maça', 'pera', 'uva']
# Estando a lista ordenada, basta apenas que o comando for realize a iteração sobre cada um dos elemento, como mostra o exemplo abaixo.

for fruta in sorted(cesta_frutas.keys()):
    print(fruta)
abacaxi
laranja
maça
pera
uva 
# Ao percorrer um dicionário o índice de posição de cada elemento e o valor correspondente podem ser recuperados, como mostra o exemplo abaixo através da função enumerate().
'''

for i, fruta in enumerate(cesta_frutas):
    print(i, fruta)
0 pera
1 uva
2 maça
3 abacaxi
4 laranja
'''
# Com o comando len() é possível visualizar o tamanho do dicionário ou a quantidade de itens que ele contém.

print(len(cesta_frutas))
5
# Armazenando dicionários em listas
# Os dicionários também podem ser armazenados em listas, através dos métodos já conhecidos como atribuição direta à variável, ou ainda, por meio do método append(). Na linha 1, é criada uma variável do tipo lista com nome compras, em seguida o dicionário frutas é criado e inicializado com um conjunto de valores inicial. Na linha 3, através da função append() o dicionário frutas é gravado na lista compras. E na linha 4, mais um dicionário é criado e inicializado com um novo conjunto de valores. As listas também são objetos iteráveis, ou seja, é possível passar por cada um dos elementos contidos e assim acessar os elementos de cada dicionário com o comando for na linha 6.

compras = []
frutas = {
            'pera': 50, 
            'uva': 2, 
            'maçã':55, 
            'abacaxi': 25
            }
compras.append(frutas)
legumes = {
            'cenoura': 3,
            'tomate': 5,
            'alface': 2
            }
compras.append(legumes)

for compra in compras:
    for k, v in compra.items():
        print(k +": " +str(v))

pera: 50
uva: 2
maçã: 55
abacaxi: 25
cenoura: 3
tomate: 5
alface: 2
# Outra forma de realizar essa atribuição e com o mesmo, é passando diretamente os dicionários a lista, como podemos ver no exemplo abaixo.

compras = [
            {
            'pera': 50, 
            'uva': 2, 
            'maçã':55, 
            'abacaxi': 25
            },
            {
            'cenoura': 3,
            'tomate': 5,
            'alface': 2
            },]

for compra in compras:
    for k, v in compra.items():
        print(k +": " +str(v))

pera: 50
uva: 2
maçã: 55
abacaxi: 25
cenoura: 3
tomate: 5
alface: 2
# Adicionando múltiplos valores nas chaves
# Conforme mostrado nas seções anteriores, até o presente foi passado um único valor para cada chave. Entretanto, é possível passar múltiplos valores a uma chave, isso pode ser feito por meio de uma lista de valores conforme mostra o exemplo abaixo.

frutas = {
            'pera': [50, 10, 20],
            'uva':  [2, 1], 
            'maçã': [55, 10, 15],
            'abacaxi': [25, 8],
            }

for fruta, qtds in frutas.items():
    print(fruta +": ")
    for qtd in qtds:
        print("= " + str(qtd))
'''

pera: 
= 50
= 10
= 20
uva: 
= 2
= 1
maçã: 
= 55
= 10
= 15
abacaxi: 
= 25
= 8
'''
# No exemplo acima, o dicionário é criado e inicializado na linha 1 com uma sequência de chaves e cada chave recebe uma lista de valores. A impressão do dicionário é realizada da seguinte forma: em um primeiro momento o comando for itera sobre as chaves e também os valores dessas chaves que são as listas. Em seguida, a cada iteração realizada um segundo for é executado iterando todos os elementos da lista que foi passada para cada uma das chaves do dicionário.

# Dicionário dentro de dicionários
# Uma segunda forma de armazenamento é criar e inicializar um dicionário que contenha outros dicionários, conforme mostra o exemplo abaixo:

compras = {
            'frutas_joao': {
            'pera': 50, 
            'uva': 2, 
            'maçã':55, 
            'abacaxi': 25,
            },
           'frutas_maria': {
            'pera': 40, 
            'uva': 3, 
            'maçã':35, 
            'abacaxi': 15,
            },}
for tipo, tipo2 in compras.items():
    print('\nTipo do item: '+ tipo)
    tudo_qtd = 'pera: '+str(tipo2['pera']) + " "
    tudo_qtd += 'uva: '+str(tipo2['uva']) + " "
    tudo_qtd += 'maçã: '+str(tipo2['maçã']) + " "
    tudo_qtd += 'abacaxi: '+str(tipo2['abacaxi'])
    
    print('Quantidade de itens comprados: '+tudo_qtd.title())

# Tipo do item: frutas_joao
# Quantidade de itens comprados: Pera: 50 Uva: 2 Maçã: 55 Abacaxi: 25

# Tipo do item: frutas_maria
# Quantidade de itens comprados: Pera: 40 Uva: 3 Maçã: 35 Abacaxi: 15
# Para realizar a impressão de todos os itens dos dicionários será necessário inicialmente iterar sobre os itens do dicionário compras, que são os dicionários frutas_joao e frutas_maria. De acordo com a ordem de inserção, o primeiro dicionário a ser impresso é frutas_joao. No comando for a variável nome recebe a chave do dicionário compras, e a variável frutas recebe as chaves do dicionário frutas_joao. Para que os valores sejam acessados, é necessário passar o nome da variável e a chave corresponde a qual desejam-se obter os valores. Os valores de cada chave são armazenados na variável tudo_qtd. Como são diversas chaves, é necessário concatenar os resultados através do operador de atribuição +=. Esse operador adiciona o conteúdo atual da variável mais o novo valor a ela mesma. Na sequência, o comando for itera sobre a outra chave frutas_maria repetindo as mesmas operações e sem seguida é realizada a impressão. Essa é uma, dentre outras formas de realizar a impressão de um dicionário um tanto mais apresentável.