# Crie um programa que leia uma frase qualquer e diga se ela é um palíndromo, desconsiderando os espaços.

frase = input("Qual a frase? ").upper().replace(" ", "")
if frase == frase[::-1]:
    print("A frase é um palíndromo")
else:
    print("A frase não é um palíndromo")
    
'''
Vou explicar o o que tá acontecendo no código. 
frase = str(input('Digite uma frase: ')).strip().upper()  

O strip() vai retirar espaços antes e depois da frase digitada. Se o usuário digita "    Ovo"  com um monte de espaços antes da palavra, na hora do programa comparar vai dar erro, porque o programa vai comparar o primeiro caractere que é o espaço com o último, que á a letra o.
o .upper() vai transformar  a palavra toda em maíuscula. Em Pyhton, maiúscula é considerado diferente de minúscula. assim, "Ovo" não é igual a "ovo", mas "OVO" é igual a "OVO".

Agora precisamos retirar os espaços entre as palavras digitadas. Porque nosso  programa vai comparar posição por posição, incusive os espaços.  Na frase "APOS A SOPA" não haveria problema porque se invertermos ficará identico , mas numa frase como "A SACADA DA CASA"  fica "ASAC AD ADACAS A"  os espaços estão em lugares diferentes, etnão o programa dirá que não é um palíndromo. Para resolver isso, vamos tirar todos os espaços entre as palavras e juntar todas as palavras. O Prof Guanabara fez isso em duas etapas. 

palavras = frase.split() 
junto = ''.join(palavras)

O splip() separa a frase onde os espaços estão e cria uma lista só com as palavras, na ordem que aprecem.
Faça um print(frase) e print(palavras) e veja que são mostrados de forma diferente.
Agora é a vez do join(). O join() junta string em uma lista, ou seja ele vai juntar as palavras que estão dentro da variável palavra, e vai colocar entre elas, o que estiver entre as aspas antes do join. como não queremos colocar nada, só juntar,  vamos ditar aspas e aspas, sem nada entre elas,  nem espaço! O resultado vai ser guardado na variável "junto".Dá um print(junto) e veja se deu certo.
Exemplo:
print(frase) >>> "A SACADA DA CASA"
print(palavras) >>>["A", "SACADA","DA","CASA"]
print(junto) >>> "ASACADADACASA"

Agora precisamos inverter a palavra que está salva na variável junto para compararmos. 

inverso = ""    

o Professor Guanabara criou uma variável 'inverso e salvou SEM espaço nela. Mas por quê?  Ele está dizendo, programa crie uma varável "inverso" VAZIA e see lembra dela que já vou usar.

for letra in range (len(junto)-1,-1,-1):
     inverso += junto[letra]

Nessa parte queremos que o programa pegue a ultima letra da palavra que está dentro de junto, e coloque em inverso, depois faça isso com a penúltima letra , assim por diante, até chegar na primeira.

for letra in range (início, fim, passo):    => estrutura genérica do range

for letra in range(inicio, fim, -1): => a leitura será reversa, então precisamos ter o passo -1

for letra in range (início, -1, -1):  => Sempre contamos a posição de uma letra começando pela posição zero. Então é normal que você pense em colocar o fim como zero, mas você deve se lembrar que a contagem não inclui a posição final, ela para na posição anterior. Como a contagem é reversa, se colocarmos zero, vai parar na posicão 1! Por isso colocamos, -1 como fim, para parar na posição zero.

for letra in range(len(junto)-1, -1,-1):  Na contagem reversa, vamos começar na última letra.  E qual é a posição da última letras? Como começamos a contar do zero, a palavra ANA, que tem três letras, terá o primeiro A na posição zero, o N na posição 1 e o último A na posição 2. Então ANA tem 3 letras e a última letra está na posição 2, que é o tamanho da palavra ( quantidade de letras)  ANA menos 1. Isso vale para todas as palavras. A ultima letra estará sempre na posição: tamanho da palavra  menos 1.  A função len() retorna um número (o tamanho da palavra), então len()-1 equivale a posição da última letra, que será o início da ordem reversa.

Imagine que:
junto = "GUSTAVOGUANABARA"
len(junto)  é igual a 16, então :

for letra in range (len(junto)-1,-1,-1): vai ser entendido como

for letra in range (15,-1,-1):
     inverso += junto[letra]

então o programa começar substituindo letra por 15 até chegar a zero

for letra in range (15,-1,-1): 
     inverso += junto[15]

junto [15] é a letra "A"

inverso += junto[15] equivale à:
inverso  =  inverso + A

Lembra de concatenação? 
a = "pala"
b = "vra"
print(a+b) 
"palavra"

é isso que vai acontecer aqui:
inverso  =  inverso + A  
significa: junte inverso com A e salve em inverso. (Ah, se não tivéssemos feito o inverso = " " antes do for, o Python ia falar ERRO, "Eu não conheço esse tal de inverso que você quer juntar com o A"

Como inverso estava vazio, então vai ficar só o A.

Depois vai ter: 
for letra in range (15,-1,-1): 
     inverso += junto[14]    +> equivale:  inverso = "A "+ "R"
na próxima:
inverso += junto[13]    +> equivale:  inverso = "AR "+ "A"
até termos:
inverso += junto[0]    +> equivale:  inverso = "ARABANAUGOVATSU"+ "G"


se dessemos um print(inverso) teremos
>>>ARABANAUGOVATSUG

depois é só comparar

if inverso == junto: vai comparar 
Se "ARABANAUGOVATSUG" é igual à "GUSTAVOGUANABARA"
 
'''