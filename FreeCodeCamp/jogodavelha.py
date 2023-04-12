# Projeto jogo da velha com IA.
# Ela nunca perde.
# Explicação do código:

import random

class JogoDaVelha:
    def __init__(self):
        self.tabuleiro = [[' ' for _ in range(3)] for _ in range(3)]
        self.jogador_atual = 'X'
    
    def imprimir_tabuleiro(self):
        for linha in self.tabuleiro:
            print('|'.join(linha))
    
    def jogada_valida(self, linha, coluna):
        if linha < 0 or linha > 2 or coluna < 0 or coluna > 2:
            return False
        if self.tabuleiro[linha][coluna] != ' ':
            return False
        return True
    
    def fazer_jogada(self, linha, coluna):
        self.tabuleiro[linha][coluna] = self.jogador_atual
        self.jogador_atual = 'O' if self.jogador_atual == 'X' else 'X'
    
    def desfazer_jogada(self, linha, coluna):
        self.tabuleiro[linha][coluna] = ' '
        self.jogador_atual = 'O' if self.jogador_atual == 'X' else 'X'
    
    def verificar_vencedor(self):
        for linha in range(3):
            if self.tabuleiro[linha][0] == self.tabuleiro[linha][1] == self.tabuleiro[linha][2] != ' ':
                return self.tabuleiro[linha][0]
            if self.tabuleiro[0][linha] == self.tabuleiro[1][linha] == self.tabuleiro[2][linha] != ' ':
                return self.tabuleiro[0][linha]
        if self.tabuleiro[0][0] == self.tabuleiro[1][1] == self.tabuleiro[2][2] != ' ':
            return self.tabuleiro[0][0]
        if self.tabuleiro[0][2] == self.tabuleiro[1][1] == self.tabuleiro[2][0] != ' ':
            return self.tabuleiro[0][2]
        for linha in range(3):
            for coluna in range(3):
                if self.tabuleiro[linha][coluna] == ' ':
                    return None
        return 'Empate'
    
    def jogada_do_computador(self):
        melhor_pontuacao = float('-inf')
        melhor_jogada = None
        for linha in range(3):
            for coluna in range(3):
                if self.tabuleiro[linha][coluna] == ' ':
                    self.fazer_jogada(linha, coluna)
                    pontuacao = self.minimax(False)
                    self.desfazer_jogada(linha, coluna)
                    if pontuacao > melhor_pontuacao:
                        melhor_pontuacao = pontuacao
                        melhor_jogada = (linha, coluna)
        self.fazer_jogada(*melhor_jogada)
    
    def minimax(self, maximizando):
        resultado = self.verificar_vencedor()
        if resultado != None:
            if resultado == 'X':
                return -1 
            
def jogada_do_usuario(self):
    linha = int(input('Digite o número da linha (0 a 2): '))
    coluna = int(input('Digite o número da coluna (0 a 2): '))
    if self.jogada_valida(linha, coluna):
        self.fazer_jogada(linha, coluna)
    else:
        print('Jogada inválida. Tente novamente.')
