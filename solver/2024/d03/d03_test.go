package main

import (
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

func TestPartOne(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/03-2_example.txt")
	expected := 161

	result, _ := partOne(in)
	if result != expected {
		t.Errorf("partOne() = %d, want %d", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/03-2_example.txt")
	expected := 48

	result, _ := partTwo(in)
	if result != expected {
		t.Errorf("partTwo() = %d, want %d", result, expected)
	}
}
