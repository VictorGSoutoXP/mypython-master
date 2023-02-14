import pygame

# Inicializando o mixer PyGame
pygame.mixer.init()

# Iniciando o Pygame
pygame.init()

pygame.mixer.music.load('ex02.mp3')
pygame.mixer.music.play(loops=0, start=0.0)
input()
pygame.event.wait()
