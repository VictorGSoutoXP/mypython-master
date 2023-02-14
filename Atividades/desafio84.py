# Validandos expressões matemáticas: Crie um programa onde o usuário digite uma expressão qualquer que use parênteses. Seu aplicativo deverá analisar se a expressão passada está com os parênteses abertos e fechados na ordem correta.

a = 0
b = 0

exp = list(input('Digite a sua expressão: ')) #entrada da expressão

for v, c in enumerate(exp):
    if '(' == exp[v]:
        a += 1
    elif ')' == exp[v] and a > 0: # a>0 indica que há um '(' antes
        b+= 1
    if a == b: #reiniciando as variáveis após um par de parênteses correto
        a = b = 0

if a == b:
    print('Sua expressão está correta!')
else:
    print('Sua expressão falta um ou mais parênteses')