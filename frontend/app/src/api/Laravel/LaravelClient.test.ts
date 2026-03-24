import { describe, it, expect, vi } from 'vitest';
import axios from 'axios';
import LaravelClient from './LaravelClient';

vi.mock('axios');

describe('LaravelClient', () => {
  it('GETリクエストでdataを返す', async () => {
    const mockGet = vi.fn().mockResolvedValue({
      data: { success: true }
    });

    (axios.create as any).mockReturnValue({
      get: mockGet
    });

    const client = LaravelClient.getInstance();

    const result = await client.get('/test');

    expect(result).toEqual({ success: true });
  });
});