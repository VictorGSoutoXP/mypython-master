# Isso e uma variavel:
var = "Oi"
# Isso e uma funcao com um parametro. O parametro e uma variavel
print(var)
# Isso e uma funcao com um parametro. O parametro e uma string imediata:
print("Oi2")
# Isso e uma funcao com dois parametros. Um parametro e uma variavel e outra e uma string imediata. separados por virgula:
print(var,"Oi3")
print("Oi4",var)
# Isso e uma funcao com tres parametros. Os  tres parametros sao variaveis e separados por viruglas:
print(var,var,var)
# Type e uma funcao que retorna o tipo do parametro que voce passa para ela. Neste caso foi passado VAR. Entao VAR2 vai receber o tipo da variavel VAR. Realizando o print do VAR2.
var2=type(var)
print(var2)
# Isso e uma funcao com um parametro. O parametro e o retorno da funcao type. O parametro da funcao type e var.
print(type(var))
#
print("Oi5", type(var))